"use client"

import React from "react"
import Link from "next/link"
import { usePathname } from "next/navigation"
import { formatToArabicDate } from "@/utils/formate-date"
import { ActionIcon, Badge, rem, Table, Tooltip } from "@mantine/core"
import { useViewportSize } from "@mantine/hooks"
import { IconEye } from "@tabler/icons-react"

import { Subscription } from "@/types/subscriptions-response"

import { TableScrollArea } from "./table-scroll-area"

type Props = {
  data: Subscription[]
}

const SubscriptionsTable = ({ data }: Props) => {
  const { height, width } = useViewportSize()
  const pathName = usePathname()
  return (
    <TableScrollArea
      minWidth={1200}
      height={height - 220 || "auto"}
      renderRows={(subscription, index) => {
        return (
          <Table.Tr key={index}>
            <Table.Td>{subscription.id}</Table.Td>
            <Table.Td>{subscription.association?.name || "غير معروف"}</Table.Td>
            <Table.Td>{subscription.unit.unit_no || "غير معروف"}</Table.Td>
            <Table.Td>{subscription.total || "غير معروف"}</Table.Td>
            <Table.Td>{subscription.payment_period_text || "غير معروف"}</Table.Td>
            <Table.Td>{subscription.next_payment_date || "غير معروف"}</Table.Td>
            <Table.Td>
              {subscription.unit.ownership_type === "individual"
                ? "فرد"
                : "مجموعة" || "غير معروف"}
            </Table.Td>
            <Table.Td>
              <Badge color={subscription.status.bg_color} radius="sm">
                {subscription.status.text}
              </Badge>
            </Table.Td>
            <Table.Td>{formatToArabicDate(subscription.due_date)}</Table.Td>

            <Table.Td>
              <div className="flex items-center gap-2">
                <Tooltip label="عرض الاشتراك">
                  <ActionIcon
                    component={Link}
                    href={`${pathName}/${subscription.id}`}
                    variant="subtle">
                    <IconEye
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
        "الجمعية",
        "كود الوحدة",
        "اجمالي الاشتراك",
        "نوع الاشتراك",
        "الدفعة القادمة",
        "فرد او مجموعه",
        "الحالة",
        "ناريخ الانتهاء",
        "إجراءات",
      ]}
    />
  )
}

export default SubscriptionsTable
