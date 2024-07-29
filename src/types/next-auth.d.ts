import type { Session, User } from "next-auth"
import type { JWT } from "next-auth/jwt"

import type { User as UserType } from "./login-response"

type UserId = string

declare module "next-auth/jwt" {
  interface JWT {
    user: UserType
  }
}
declare module "next-auth" {
  interface Session {
    user: User & UserType
  }
}
