"use client"

import React from "react"
import { useParams } from "next/navigation"
import { getTicket } from "@/api/helpers/get-ticket"
import { formatToArabicDate } from "@/utils/formate-date"
import { Avatar, Badge, Loader } from "@mantine/core"
import { useQuery } from "@tanstack/react-query"
import { useSession } from "next-auth/react"

import Error from "@/components/ui/error"

import AddReply from "./add-reply"
import RateReply from "./rate-reply"

const Ticket = () => {
  const { ticket_id } = useParams() as { ticket_id: string }
  const { error, isLoading, data } = useQuery({
    queryKey: ["ticket", ticket_id],
    queryFn: async () => {
      return await getTicket({ ticket_id })
    },
  })

  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض الطلب لديك " error={error} />

  if (isLoading)
    return (
      <div className="flex h-[calc(100vh-200px)] items-center justify-center">
        <Loader size={"lg"} />
      </div>
    )

  if (!data)
    return <Error message=" عذرا ,لم نتمكن من عرض الطلب لديك " error={error} />

  const ticket = data?.data?.ticket

  return (
    <>
      <div className=" mb-6 rounded-lg border bg-white  shadow-sm">
        <div className="flex w-full items-center justify-between gap-4   bg-gray-100  px-4 py-6 ">
          <div>
            <h1 className="py-2 text-xl font-semibold">
              عنوان الطلب: <span className=" text-gray-500"> {ticket.title}</span>{" "}
              <Badge size="sm" className="text-xs">
                {ticket.code}
              </Badge>
            </h1>
            <div className=" flex gap-3">
              <span className="font-gray-400 text-xs">
                الجمعية: {ticket.association?.name || "غير معروف"}
              </span>
              <span className="font-gray-400 text-xs">
                تاريخ: {formatToArabicDate(ticket.created_at)}
              </span>
            </div>
          </div>
          <div>
            <Badge size="lg" color={ticket.status.bg_color} radius="sm">
              {ticket.status.text}
            </Badge>
          </div>
        </div>
        <div className="min-h-[250px] p-4 py-6 text-gray-700 ">
          {ticket.content.content}
        </div>
        <div className="mb-4 flex flex-wrap gap-4">
          {ticket.replies.toReversed()[0].attachments.map((file, index) => {
            return (
              <div
                key={`file_${file.id}_${index}`}
                className="relative rounded-lg border border-gray-200 shadow-lg">
                <div className=" p-4">
                  <div>
                    <a
                      href={file.path}
                      target="_blank"
                      rel="noopener"
                      download
                      className="font-medium text-gray-900">
                      {file.path.split("/").slice(-1)}
                    </a>
                  </div>
                </div>
              </div>
            )
          })}
        </div>
      </div>
      <div className="py-6">
        <p className="text-xl font-semibold">الردود:</p>
      </div>
      <div className=" space-y-6">
        {ticket.replies
          .toReversed()
          .slice(1)
          .map((reply) => {
            return (
              <div key={reply.id} className="rounded-lg border bg-white shadow-sm">
                <div className=" flex w-full items-center justify-between  gap-3 bg-gray-100  px-2 py-4 ">
                  <div className=" flex w-full items-center  gap-3">
                    <Avatar size={"sm"} src={reply.user?.avatar} />
                    <div>
                      <p className="text-sm font-semibold">
                        الأسم:{reply.user?.name || "غير معروف"}
                      </p>
                      <span className="text-xs text-gray-500">
                        {reply.user?.role}
                      </span>
                    </div>
                  </div>
                  {reply.user?.type === "admin" ? (
                    <RateReply stars={reply.stars} id={reply.id} />
                  ) : null}
                </div>
                <div className="min-h-[250px] p-4 py-6 text-gray-700 ">
                  {reply.body}
                </div>
                <div className="mb-4 flex flex-wrap gap-4">
                  {reply.attachments.map((file, index) => {
                    return (
                      <div
                        key={`file_${file.id}_${index}`}
                        className="relative rounded-lg border border-gray-200 shadow-lg">
                        <div className=" p-4">
                          <div>
                            <a
                              href={file.path}
                              target="_blank"
                              rel="noopener"
                              download
                              className="font-medium text-gray-900">
                              {file.path.split("/").slice(-1)}
                            </a>
                          </div>
                        </div>
                      </div>
                    )
                  })}
                </div>
              </div>
            )
          })}
      </div>
      <AddReply />
    </>
  )
}

export default Ticket
