"use client"

import React from "react"
import { useParams } from "next/navigation"
import { getTicketAttachments } from "@/api/helpers/get-ticket-attachments"
import { useQuery } from "@tanstack/react-query"
import { useSession } from "next-auth/react"

import Error from "@/components/ui/error"

const TicketAttachments = () => {
  const { ticket_id, association_id } = useParams() as {
    ticket_id: string
    association_id: string
  }
  const { error, isLoading, data } = useQuery({
    queryKey: ["ticket-attachments", ticket_id],
    queryFn: async () => {
      return await getTicketAttachments({
        ticket_id,
      })
    },
  })

  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض  الملحقات " error={error} />

  const attachments = data?.data

  return (
    <div>
      <div className="rounded-lg border bg-white shadow-sm">
        <div className=" bg-gray-100  px-2 py-4 ">
          <div>
            <p className="text-sm font-semibold">جميع الملحقات</p>
          </div>
        </div>
        <div className="min-h-[250px] space-y-3 p-3 py-3  text-gray-700">
          {attachments?.map((file, index) => {
            return (
              <a
                key={file.id + file.path}
                href={file.path}
                target="_blank"
                rel="noopener"
                download
                className="block bg-slate-50 px-2 py-2 font-medium  text-gray-900 duration-200 hover:text-Primary">
                {file.path.split("/").slice(-1)}
              </a>
            )
          })}
        </div>
      </div>
    </div>
  )
}

export default TicketAttachments
