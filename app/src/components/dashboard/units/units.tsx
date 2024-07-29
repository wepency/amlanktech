"use client"

import React, { useRef } from "react"
import { getUnits } from "@/api/helpers/get-units"
import { Loader } from "@mantine/core"
import {
  IconAlertSquareRounded,
  IconCheckbox,
  IconHourglassHigh,
} from "@tabler/icons-react"

import { UnitsResponse } from "@/types/units-response"
import useInfiniteQuery from "@/hooks/use-infinite-query"
import Error from "@/components/ui/error"
import { StatsGrid } from "@/components/ui/status-grid"
import AddNewUnit from "@/components/dashboard/units/add-new"
import UnitsTable from "@/components/table/units-table"

type Props = {}

const Units = (props: Props) => {
  const ref = useRef<React.ElementRef<"div">>(null)
  const { error, data, isFetching, isFetchingNextPage } =
    useInfiniteQuery<UnitsResponse>({
      queryKey: ["units"],
      fetcher: getUnits,
      ref: ref,
    })

  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض الوحدات لديك " error={error} />

  if (!isFetching && data?.pages.flatMap((e) => e.data.units).length === 0) {
    return <p className="py-5 text-center">لا يوجد اي وحدات حاليا</p>
  }

  const units = data?.pages!.flatMap((element) => element.data.units)!

  const stats = [
    {
      title: "الوحدات النشطة",
      Icon: IconCheckbox,
      value: data!.pages[0].data.active_units,
      des: `عدد الوحدات النشطة هو ${data?.pages[0].data.active_units}`,
    },
    {
      title: "الوحدات المتوقفة",
      Icon: IconAlertSquareRounded,
      value: data!.pages[0].data.blocked_units,
      des: "تم ايقاف هذة الوحدات سواء من قبلك ام من قبل الجمعية",
    },
    {
      title: "وحدات قيد المراجعة",
      Icon: IconHourglassHigh,
      value: data!.pages[0].data.pending_units,
      des: "سيتم مراجعة وحداتك من قبل ادارة الجمعية ",
    },
  ]
  return (
    <div>
      <StatsGrid data={stats} />
      <div className="mt-6 min-h-[calc(100vh-630px)] rounded-lg border bg-white px-4 py-6   shadow">
        <div className="mb-10 flex justify-between">
          <h1 className=" text-xl font-bold">جميع الوحدات</h1>
          <AddNewUnit />
        </div>
        <UnitsTable data={units} />
        {isFetchingNextPage && (
          <div className="flex items-center justify-center py-10">
            <Loader />
          </div>
        )}
        <div className="h-5 " ref={ref}></div>
      </div>
    </div>
  )
}

export default Units
