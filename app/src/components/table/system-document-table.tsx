"use client"

import React from "react"
import { formatToArabicDate } from "@/utils/formate-date"
import { ActionIcon, rem, Table, Tooltip } from "@mantine/core"
import { IconDownload } from "@tabler/icons-react"

import { SystemDocument } from "@/types/system-documents-response"

import { TableScrollArea } from "./table-scroll-area"

type Props = {
  data: SystemDocument[]
}

const SystemDocTable = ({ data }: Props) => {
  return (
    <TableScrollArea
      minWidth={550}
      height={"auto"}
      renderRows={(document, index) => {
        return (
          <Table.Tr key={index}>
            <Table.Td>{document.id}</Table.Td>
            <Table.Td>{document.title}</Table.Td>

            <Table.Td>{formatToArabicDate(new Date(document.created_at))}</Table.Td>

            <Table.Td>
              <div className="flex items-center gap-2">
                <Tooltip label="تنزيل الملف">
                  <ActionIcon color="green" variant="subtle">
                    <a href={document.document_link || document.file_path} download>
                      <IconDownload
                        style={{ width: rem(22), height: rem(22) }}
                        stroke={1.5}
                      />
                    </a>
                  </ActionIcon>
                </Tooltip>
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
      headerData={["ID", "عنوان", "اخر تعديل", "إجراءات"]}
    />
  )
}

export default SystemDocTable
