import React from "react"
import { getUnit } from "@/api/helpers/get-unit"
import { Badge } from "@mantine/core"

import { Status, type Unit as UnitType } from "@/types/units-response"

type Props = {
  params: {
    unit_id: string
  }
}

const translateKeyMap = {
  id: "ID",
  area: "المساحة",
  unit_no: "كود الوحدة",
  association_id: "رقم الجمعية",
  fee_type_amount: "رسوم الاشتراك",
  fee_type_total: "رسوم الاشتراك",
  ownership_type: "نوع الملكية",
  ownership_ratio: "نسبة الملكية",
  address: "العنوان",
  water_meter_serial: "رقم عداد الكهرباء",
  electricity_meter_serial: "رقم عداد المياه",
  created_time: "وقت  الإضافة",
  association: "الجمعية",
  created_at_formatted: "تاريخ الاضافة",
  updated_at_formatted: "تاريخ اخر تحديث",
  created_at: "تاريخ الاضافة",
  updated_at: "تاريخ اخر تحديث",
  status: "الحالة",
}

const unWantedValues = ["updated_at", "created_at"]

const page = async ({ params: { unit_id } }: Props) => {
  const unit = (await getUnit({ unit_id })).data.unit

  return (
    <section>
      <div className=" min-h-[calc(100vh-110px)] rounded-lg border bg-white px-4 py-6   shadow">
        <h1 className=" mb-10 text-xl font-bold">تفاصيل الوحدة</h1>

        <div className="flow-root w-full">
          <dl className="-my-3 divide-y divide-gray-100 text-sm">
            {Object.keys(unit).map((v, index) => {
              let key = v as keyof UnitType
              let value = unit[key]

              if (value instanceof Date) {
                value = null
              }
              if (
                value &&
                typeof value === "object" &&
                "registration_number" in value
              ) {
                value = value.name
              }
              if (unWantedValues.includes(key) || !value) return null
              return (
                <div
                  key={`unit_${key}_${index}`}
                  className="grid grid-cols-1 gap-1 py-3 even:bg-gray-50 sm:grid-cols-3 sm:gap-4">
                  <dt className="font-medium text-gray-900">
                    {translateKeyMap[key]}
                  </dt>
                  {key === "status" ? (
                    <dd>
                      <Badge
                        color={
                          (value as Status).color_type === "warning"
                            ? "yellow"
                            : (value as Status).color_type === "success"
                              ? "green"
                              : "red"
                        }
                        radius="sm">
                        {(value as Status).text}
                      </Badge>
                    </dd>
                  ) : (
                    <dd className="text-gray-700 sm:col-span-2">
                      {value.toString()}
                    </dd>
                  )}
                </div>
              )
            })}
          </dl>
        </div>
      </div>
    </section>
  )
}

export default page
