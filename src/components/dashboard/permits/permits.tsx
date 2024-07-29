"use client"

import React from "react"
import { useParams } from "next/navigation"
import { getPermits } from "@/api/helpers/get-permits"
import { useQuery } from "@tanstack/react-query"

import Error from "@/components/ui/error"
import PermitsTable from "@/components/table/permits-table"

import AddPermit from "./add-new"

type Props = {}

const Permits = (props: Props) => {
  const { association_id } = useParams() as { association_id: string }

  const { data, error, isFetching, isLoading } = useQuery({
    queryKey: ["permits", association_id],
    queryFn: async () =>
      await getPermits({
        association_id,
      }),
  })
  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض التصاريح لديك " error={error} />

  return (
    <div>
      <div className="min-h-[calc(100vh-110px)] rounded-lg border bg-white px-4 py-6   shadow">
        <div className="mb-10 flex justify-between">
          <h1 className=" text-xl font-bold">جميع التصاريح</h1>
          <AddPermit />
        </div>
        {!isLoading && data?.data?.permits.length === 0 ? (
          <p className="py-5 text-center">لا يوجد اي تصاريح حاليا</p>
        ) : (
          <PermitsTable data={data?.data.permits!} />
        )}
      </div>
    </div>
  )
}
export default Permits
