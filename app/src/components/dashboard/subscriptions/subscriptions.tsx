"use client"

import React from "react"
import { useParams } from "next/navigation"
import { getSubscriptions } from "@/api/helpers/get-subscriptions"
import { useQuery } from "@tanstack/react-query"

import Error from "@/components/ui/error"
import SubscriptionsTable from "@/components/table/subscriptions-table"

type Props = {}

const Subscriptions = (props: Props) => {
  const { association_id } = useParams() as { association_id: string }
  const { data, error, isFetching, isLoading } = useQuery({
    queryKey: ["subscriptions", association_id],
    queryFn: async () =>
      await getSubscriptions({
        association_id,
      }),
  })
  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض الاشتراكات لديك " error={error} />

  return (
    <div>
      <div className="min-h-[calc(100vh-130px)] rounded-lg border bg-white px-4 py-6   shadow">
        <div className="mb-10 flex justify-between">
          <h1 className=" text-xl font-bold">جميع الاشنراكات</h1>
        </div>
        {!isLoading && data?.data.subscriptions.length === 0 ? (
          <p className="py-5 text-center">لا يوجد اي اشتراكات حاليا</p>
        ) : (
          <SubscriptionsTable data={data?.data.subscriptions!} />
        )}
      </div>
    </div>
  )
}
export default Subscriptions
