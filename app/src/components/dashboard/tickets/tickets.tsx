"use client"

import React from "react"
import { useParams } from "next/navigation"
import { getTickets } from "@/api/helpers/get-tickets"
import { useQuery } from "@tanstack/react-query"

import Error from "@/components/ui/error"
import TicketsTable from "@/components/table/tickets-table"

import AddNewTicket from "./add-new"

type Props = {}

const Tickets = (props: Props) => {
  const { association_id } = useParams() as { association_id: string }
  const { data, error, isFetching, isLoading } = useQuery({
    queryKey: ["tickets", association_id],
    queryFn: async () =>
      await getTickets({
        association_id,
      }),
  })
  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض الطلبات لديك " error={error} />

  return (
    <div>
      {/* <StatsGrid data={stats} /> */}
      <div className="min-h-[calc(100vh-110px)] rounded-lg border bg-white px-4 py-6   shadow">
        <div className="mb-10 flex justify-between">
          <h1 className=" text-xl font-bold">جميع الطلبات</h1>
          <AddNewTicket />
        </div>
        {!isLoading && data?.data.tickets.length === 0 ? (
          <p className="py-5 text-center">لا يوجد اي طلبات حاليا</p>
        ) : (
          <TicketsTable data={data?.data.tickets!} />
        )}
      </div>
    </div>
  )
}
export default Tickets
