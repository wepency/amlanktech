"use client"

import React from "react"
import Link from "next/link"
import { useParams } from "next/navigation"
import { deletePermit } from "@/api/helpers/delete-permit"
import { ActionIcon, Badge, rem, Table, Text, Tooltip } from "@mantine/core"
import { useViewportSize } from "@mantine/hooks"
import { modals } from "@mantine/modals"
import { notifications } from "@mantine/notifications"
import { IconEye, IconTrash } from "@tabler/icons-react"
import { useQueryClient } from "@tanstack/react-query"

import { Permit } from "@/types/permits-response"

import { TableScrollArea } from "./table-scroll-area"

type Props = {
  data: Permit[]
}

const PermitsTable = ({ data }: Props) => {
  const { height } = useViewportSize()

  const { association_id } = useParams() as { association_id: string }

  const queryClient = useQueryClient()

  const openModal = (permit: Permit) =>
    modals.openConfirmModal({
      title: "هل انت متأكد",
      children: <Text size="sm">انت على وشك حذف تصريح ال{permit.type}</Text>,
      labels: { confirm: "تاكيد", cancel: "الغاء" },
      onCancel: () => console.log("Cancel"),
      onConfirm: async () => {
        try {
          await deletePermit({
            id: permit.id,
          })
          await queryClient.refetchQueries({
            queryKey: ["permits", association_id],
          })
          notifications.show({
            title: "تمت العملية بنجاح",
            message: "تم حذف  التصريح الخص بك بنجاح .",
          })
        } catch (error) {
          notifications.show({
            color: "red",
            title: "فشلت العملية",
            message: "لم يتم حذف التصريح!",
          })
        }
      },
    })

  return (
    <>
      <TableScrollArea
        minWidth={950}
        height={height - 240 || "auto"}
        renderRows={(permit, index) => {
          return (
            <Table.Tr key={index}>
              <Table.Td>{permit.id}</Table.Td>
              <Table.Td>{permit.type || "غير معروف"}</Table.Td>
              <Table.Td>{permit.association?.name || "غير معروف"}</Table.Td>
              <Table.Td>
                <Badge autoContrast color={permit.status.bg_color} radius="sm">
                  {permit.status.text}
                </Badge>
              </Table.Td>
              <Table.Td>{permit.start_date}</Table.Td>
              <Table.Td>{permit.duration}</Table.Td>
              <Table.Td>{permit.login_attempts}</Table.Td>
              <Table.Td>{permit.visitors.length}</Table.Td>
              {/* 
            <Table.Td>
              {application.deleted_at ? formatToArabicDate(application.deleted_at) : null}
            </Table.Td> */}
              <Table.Td>
                <div className="flex items-center gap-2">
                  <Tooltip label="عرض التصريح">
                    <ActionIcon
                      component={"a"}
                      href={permit.link}
                      rel="noopener"
                      target="_blank"
                      variant="subtle">
                      <IconEye
                        style={{ width: rem(22), height: rem(22) }}
                        stroke={1.5}
                      />
                    </ActionIcon>
                  </Tooltip>
                  <Tooltip label="حذف التصريح">
                    <ActionIcon
                      onClick={() => {
                        openModal(permit)
                      }}
                      color="red"
                      variant="subtle">
                      <IconTrash
                        color="red"
                        style={{ width: rem(22), height: rem(22) }}
                        stroke={1.5}
                      />
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
        headerData={[
          "ID",
          "نوع التصريح",
          "الجمعية",
          "الحالة",
          "تاريخ السريان",
          "عدد أيام التصريح",
          "مرات الدخول",
          "عدد الزائرين",
          "إجراءات",
        ]}
      />
    </>
  )
}

export default PermitsTable
