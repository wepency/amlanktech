import React from "react"
import { getServerSession } from "next-auth"

import { authOptions } from "@/lib/next-auth"
import NextAuthSessionProvider from "@/lib/next-auth-provider"

type Props = {
  children: React.ReactNode
}
export const dynamic = "force-dynamic"

const DashboardLayout = async ({ children }: Props) => {
  const session = await getServerSession(authOptions)
  return (
    <NextAuthSessionProvider session={session}>{children}</NextAuthSessionProvider>
  )
}

export default DashboardLayout
