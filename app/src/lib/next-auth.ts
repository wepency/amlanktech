import AmlackApi from "@/api"
import axios from "axios"
import type { NextAuthOptions } from "next-auth"
import CredentialsProvider from "next-auth/providers/credentials"

import { LoginResponse, User } from "@/types/login-response"

export const authOptions: NextAuthOptions = {
  providers: [
    CredentialsProvider({
      name: "Credentials",
      credentials: {},
      // @ts-expect-error
      async authorize(credentials, req) {
        const { username, password } = credentials as {
          username: string
          password: string
        }
        try {
          const response = await AmlackApi.post<LoginResponse>("/login", {
            username,
            password,
          })

          // console.log(response.data)

          const user = response.data.data[0]

          // If no error and we have user data, return it
          if (user) {
            return user
          }
        } catch (error) {
          console.log("🚀 ~ authorize ~ error:", error)
          if (axios.isAxiosError(error) && error.response?.status === 403) {
            return { error: error.response?.data.errors[0] || "حصل مشكلة ما" }
          }
          if (axios.isAxiosError(error) && error.response?.status === 401) {
            return { error: error.response?.data.errors[0] || "حصل مشكلة ما" }
          }
          return {
            error: "خطا غير معروف",
          }
        }
      },
    }),
  ],
  callbacks: {
    async signIn({ user }) {
      if ((user as any)?.error) {
        throw new Error((user as any).error)
      }
      return true
    },
    async jwt({ token, user }) {
      return { ...user, ...token }
    },
    async session({ session, token }) {
      session.user = token as any
      return session
    },
  },

  session: {
    // strategy: 'database',
    // easier to work with, we can handle it in a middelware
    strategy: "jwt",
  },
  pages: {
    signIn: "/login",
  },
}
