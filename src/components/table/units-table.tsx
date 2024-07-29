"use client"

import React from "react"
import Link from "next/link"
import { usePathname } from "next/navigation"
import { formatToArabicDate } from "@/utils/formate-date"
import { ActionIcon, Badge, rem, Table, Tooltip } from "@mantine/core"
import { IconEdit, IconEye, IconTrash } from "@tabler/icons-react"

import { Unit } from "@/types/units-response"

import { TableScrollArea } from "./table-scroll-area"

type Props = {
  data: Unit[]
}

const UnitsTable = ({ data }: Props) => {
  const pathName = usePathname()
  return (
    <TableScrollArea
      minWidth={750}
      height={"auto"}
      renderRows={(unit, index) => {
        return (
          <Table.Tr key={index}>
            <Table.Td>{unit.id}</Table.Td>
            <Table.Td>{unit.address}</Table.Td>
            <Table.Td>{unit.association?.name || "غير معروف"}</Table.Td>
            <Table.Td>
              <Badge
                color={
                  unit.status.color_type === "warning"
                    ? "yellow"
                    : unit.status.color_type === "success"
                      ? "green"
                      : "red"
                }
                radius="sm">
                {unit.status.text}
              </Badge>
            </Table.Td>
            {/* <Table.Td>{unit.area + "م^2"}</Table.Td> */}
            {/* <Table.Td>{unit.association_id || "غير معروف"}</Table.Td> */}
            {/* <Table.Td>{unit.association_member_id}</Table.Td> */}
            <Table.Td>
              {unit.ownership_type === "group" ? "شراكة" : "ملكية خاصة"}
            </Table.Td>
            {/* <Table.Td>{unit.ownership_ratio || "غير معروف"}</Table.Td> */}
            <Table.Td>{unit.fee_type_total + " رس" || "غير معروف"}</Table.Td>
            {/* <Table.Td>{unit.electricity_meter_serial}</Table.Td> */}
            {/* <Table.Td>{unit.water_meter_serial}</Table.Td> */}
            {/* <Table.Td>{formatToArabicDate(unit.created_at)}</Table.Td> */}
            {/* <Table.Td>{formatToArabicDate(unit.updated_at)}</Table.Td> */}
            {/* 
            <Table.Td>
              {unit.deleted_at ? formatToArabicDate(unit.deleted_at) : null}
            </Table.Td> */}
            <Table.Td>
              <div className="flex items-center gap-2">
                <Tooltip label="عرض الوحدة">
                  <ActionIcon
                    variant="subtle"
                    component={Link}
                    href={`${pathName}/${unit.id}`}>
                    <IconEye
                      style={{ width: rem(22), height: rem(22) }}
                      stroke={1.5}
                    />
                  </ActionIcon>
                </Tooltip>
                {/* <Tooltip label="تعديل الوحدة">
                  <ActionIcon color="green" variant="subtle">
                    <IconEdit
                      color="green"
                      style={{ width: rem(22), height: rem(22) }}
                      stroke={1.5}
                    />
                  </ActionIcon>
                </Tooltip>

                <Tooltip label="حذف الوحدة">
                  <ActionIcon color="red" variant="subtle">
                    <IconTrash
                      color="red"
                      style={{ width: rem(22), height: rem(22) }}
                      stroke={1.5}
                    />
                  </ActionIcon>
                </Tooltip> */}
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
        "العنوان",
        "الجمعية",
        "الحالة",
        // "المساحة",
        "نوع الملكية",
        // "نسبة الملكية",
        "رسوم الاشتراك",
        // "رقم اشتراك الكهرباء",
        // "رقم اشتراك المياه",
        // "تاريخ اضافة الوحدة",
        // "اخر تعديل للوحدة",
        // "Actions",
      ]}
    />
  )
}

export default UnitsTable
