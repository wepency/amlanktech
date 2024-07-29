import React from "react"
import { redirect } from "next/navigation"
import { getServerSession } from "next-auth"

import { authOptions } from "@/lib/next-auth"

import { AuroraBackground } from "../../components/aurora-background"

type Props = {
  children: React.ReactNode
}

const AuthLayout = async ({ children }: Props) => {
  const session = await getServerSession(authOptions)
  if (session) redirect("/dashboard")

  return <AuroraBackground>{children}</AuroraBackground>
}

export default AuthLayout
