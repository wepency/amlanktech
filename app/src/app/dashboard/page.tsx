import React from "react"
import Link from "next/link"
import { redirect } from "next/navigation"
import { getUserData } from "@/api/helpers/get-me"
import { Button } from "@mantine/core"
import { getServerSession } from "next-auth"

import { authOptions } from "@/lib/next-auth"
import { AuroraBackground } from "@/components/aurora-background"

type Props = {}

const page = async (props: Props) => {
  const session = await getServerSession(authOptions)
  const userData = await getUserData()
  if (!session) redirect("/login")

  return (
    <AuroraBackground>
      <section className="flex min-h-screen items-center justify-center   text-center backdrop-blur">
        <div>
          <h1 className="mb-10 text-xl font-bold">أختر جمعية للمتابعة</h1>
          <div className="flex flex-wrap gap-4">
            {userData.data.associations.map((association, index) => {
              return (
                <Link
                  className=" bg-white px-4 py-2 shadow "
                  href={`/dashboard/${association.id}/`}
                  key={`association_${index}`}>
                  {association.name}
                </Link>
              )
            })}
          </div>
          <div className=" flex justify-center py-4">
            <Button
              size="sm"
              variant="default"
              href={"/dashboard/join"}
              component={Link}>
              تسجيل في جمعية جديدة
            </Button>
          </div>
        </div>
      </section>
    </AuroraBackground>
  )
}

export default page
