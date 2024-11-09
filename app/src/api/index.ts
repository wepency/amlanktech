import axios from "axios"
import { getSession } from "next-auth/react"

// const baseURL = "https://dash.amlaktech.com/api"
const baseURL = "http://127.0.0.1:8000/api"

const AmlackApi = axios.create({
  baseURL: baseURL,
})

// Add a request interceptor to include the authentication token
AmlackApi.interceptors.request.use(
  async (config) => {
    let session

    if (typeof window === "undefined") {
      // Server-side
      const { getServerSession } = await import("next-auth")
      const { authOptions } = await import("@/lib/next-auth")
      session = await getServerSession(authOptions)
    } else {
      // Client-side
      session = await getSession()
    }

    if (session?.user?.access_token) {
      config.headers["Authorization"] = `Bearer ${session.user.access_token}`
    }

    return config
  },
  (error) => {
    // Do something with request error
    return Promise.reject(error)
  },
)

export default AmlackApi
