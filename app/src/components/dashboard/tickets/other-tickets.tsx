"use client"

import React from "react"
import Link from "next/link"
import { useParams } from "next/navigation"
import { getOtherTickets } from "@/api/helpers/get-other-tickets"
import { Badge } from "@mantine/core"
import { useQuery } from "@tanstack/react-query"

import Error from "@/components/ui/error"

const OtherTickets = () => {
  const { ticket_id, association_id } = useParams() as {
    ticket_id: string
    association_id: string
  }
  const { error, isLoading, data } = useQuery({
    queryKey: ["other-tickets", ticket_id],
    queryFn: async () => {
      return await getOtherTickets({
        ticket_id,
        association_id,
      })
    },
  })

  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض الطلب لديك " error={error} />

  const tickets = data?.data.tickets

  return (
    <div>
      <div className="rounded-lg border bg-white shadow-sm">
        <div className=" bg-gray-100  px-2 py-4 ">
          <div>
            <p className="text-sm font-semibold">طلبات اخرى</p>
          </div>
        </div>
        <div className="min-h-[250px] space-y-3 p-3 py-3  text-gray-700">
          {tickets?.map((ticket, index) => {
            return (
              <Link
                href={`/dashboard/${association_id}/tickets/${ticket.id}`}
                key={ticket.code + ticket.id}
                className="flex items-center justify-between gap-3 bg-slate-50  p-2 duration-200 hover:text-Primary">
                <p>{ticket.title}</p>
                <Badge size="sm" color={ticket.status.bg_color} radius="sm">
                  {ticket.status.text}
                </Badge>
              </Link>
            )
          })}
        </div>
      </div>
    </div>
  )
}

export default OtherTickets
