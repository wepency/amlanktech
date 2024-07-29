import React from "react"
import { getServerSession } from "next-auth"

import { authOptions } from "@/lib/next-auth"
import { SideBar } from "@/components/dashboard/side-bar"
import TopBar from "@/components/dashboard/top-bar"

type Props = {
  children: React.ReactNode
}
export const dynamic = "force-dynamic"

const DashboardLayout = async ({ children }: Props) => {
  const session = await getServerSession(authOptions)

  return (
    <main>
      <SideBar />
      <TopBar user={session!.user.user!} />
      <div className="pl-5 pr-[84px] pt-24 md:pr-[104px]">{children}</div>
    </main>
  )
}

export default DashboardLayout
