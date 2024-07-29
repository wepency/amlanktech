"use client"

import React from "react"
import { SessionProvider } from "next-auth/react"

type Props = {
  session: any
  children: React.ReactNode
}

const NextAuthSessionProvider = ({ session, children }: Props) => {
  return <SessionProvider session={session}>{children}</SessionProvider>
}

export default NextAuthSessionProvider
