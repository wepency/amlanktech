"use client"

import React, { useEffect, useRef } from "react"
import { getMeetings } from "@/api/helpers/get-meetings"
import { Loader } from "@mantine/core"

import { MeetingsResponse } from "@/types/meetings-response"
import useInfiniteQuery from "@/hooks/use-infinite-query"
import Error from "@/components/ui/error"

import MeetingCard from "./meeting-card"

type Props = {}

const Meetings = (props: Props) => {
  const ref = useRef<React.ElementRef<"div">>(null)
  const { error, data, isFetching, isFetchingNextPage, isLoading } =
    useInfiniteQuery<MeetingsResponse>({
      queryKey: ["meetings"],
      fetcher: getMeetings,
      ref: ref,
    })

  if (error)
    return <Error message=" عذرا ,لم نتمكن من عرض الإجتماعات لديك " error={error} />

  if (!isFetching && data?.pages.flatMap((e) => e.data).length === 0) {
    return <p className="py-5 text-center">لا يوجد اي منشورات حاليا</p>
  }

  const meetings = data?.pages!.flatMap((element) => element.data.meetings)
  console.log("🚀 ~ Meetings ~ meetings:", meetings)
  return (
    <>
      <div className="flex flex-wrap  gap-5 ">
        {meetings?.map((meeting) => {
          return <MeetingCard key={meeting.id} {...meeting} />
        })}
      </div>
      {isFetchingNextPage && (
        <div className="flex items-center justify-center py-10">
          <Loader />
        </div>
      )}
      <div className="h-5 " ref={ref}></div>
    </>
  )
}

export default Meetings
