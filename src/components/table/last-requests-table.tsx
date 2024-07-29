"use client"

import React from "react"
import { ActionIcon, rem, Table } from "@mantine/core"
import { IconEye } from "@tabler/icons-react"

import { TableScrollArea } from "./table-scroll-area"

type Props = {
  data: {
    id: string | number
    subject: string
    date: string
    actions: { icon: string }[]
  }[]
}

const LastRequestsTable = ({ data }: Props) => {
  return (
    <TableScrollArea
      minWidth={390}
      renderRows={(element, index) => {
        return (
          <Table.Tr key={index}>
            <Table.Td>{element.id}</Table.Td>
            <Table.Td>{element.subject}</Table.Td>
            <Table.Td>{element.date}</Table.Td>
            <Table.Td>
              <ActionIcon variant="subtle">
                <IconEye style={{ width: rem(22), height: rem(22) }} stroke={1.5} />
              </ActionIcon>
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
      headerData={["ID", "الموضوع", "التاريخ", "إجراءات"]}
    />
  )
}

export default LastRequestsTable
