"use client"

import React from "react"
import Link from "next/link"
import { usePathname } from "next/navigation"
import { formatToArabicDate } from "@/utils/formate-date"
import { ActionIcon, Badge, rem, Table, Tooltip } from "@mantine/core"
import { useViewportSize } from "@mantine/hooks"
import { IconExclamationCircle, IconEye } from "@tabler/icons-react"

import { Ticket } from "@/types/tickets-response"

import ApplyForAppeal from "../dashboard/tickets/apply-for-appeal"
import { TableScrollArea } from "./table-scroll-area"

type Props = {
  data: Ticket[]
}

const TicketsTable = ({ data }: Props) => {
  const { height, width } = useViewportSize()
  const pathName = usePathname()
  return (
    <TableScrollArea
      minWidth={450}
      height={height - 240 || "auto"}
      renderRows={(ticket, index) => {
        return (
          <Table.Tr key={index}>
            <Table.Td>{ticket.id}</Table.Td>
            <Table.Td>{ticket.title || "غير معروف"}</Table.Td>
            <Table.Td>{ticket.association?.name || "غير معروف"}</Table.Td>
            <Table.Td>{ticket.category || "غير معروف"}</Table.Td>
            <Table.Td>
              <Badge color={ticket.status.bg_color} radius="sm">
                {ticket.status.text}
              </Badge>
            </Table.Td>
            <Table.Td>{formatToArabicDate(ticket.created_at)}</Table.Td>
            {/* 
            <Table.Td>
              {application.deleted_at ? formatToArabicDate(application.deleted_at) : null}
            </Table.Td> */}
            <Table.Td>
              <div className="flex items-center gap-2">
                <Tooltip label="عرض الطلب">
                  <ActionIcon
                    component={Link}
                    href={`${pathName}/${ticket.id}`}
                    variant="subtle">
                    <IconEye
                      style={{ width: rem(22), height: rem(22) }}
                      stroke={1.5}
                    />
                  </ActionIcon>
                </Tooltip>
                <ApplyForAppeal {...ticket} />
              </div>
            </Table.Td>
          </Table.Tr>
        )
      }}
      renderTableHeader={(element) => (
        <Table.Th className="bg-white px-2 py-4" key={element}>
          {element}
        </Table.Th>
      )}
      data={data}
      headerData={[
        "ID",
        "عنوان الطلب",
        "الجمعية",
        "نوع التطلب",
        "الحالة",
        "تاريخ تقديم الطلب",
        "إجراءات",
      ]}
    />
  )
}

export default TicketsTable
