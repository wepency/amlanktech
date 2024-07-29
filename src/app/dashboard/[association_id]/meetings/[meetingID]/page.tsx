"use client"

import { getMeeting } from "@/api/helpers/get-meeting"
import { Loader } from "@mantine/core"
import { useQuery } from "@tanstack/react-query"
import { useSession } from "next-auth/react"

import { MeetingResponse } from "@/types/meeting-response"
import Error from "@/components/ui/error"
import Meeting from "@/components/dashboard/meetings/meeting"

export default function ZoomMeeting({
  params,
}: {
  params: {
    meetingID: string
  }
}) {
  const { meetingID } = params

  const session = useSession()
  const { data, isFetching, isLoading, error } = useQuery<MeetingResponse>({
    queryKey: ["meeting", meetingID],
    queryFn: async () => {
      return await getMeeting({
        meetingID: meetingID,
      })
    },
  })

  return (
    <div className=" flex min-h-[calc(100vh-110px)] items-center justify-center  rounded-lg border bg-white px-4 py-6 pb-10 shadow">
      {isLoading ? (
        <div className="flex h-[300px] w-full  items-center justify-center">
          <Loader size={"lg"} />
        </div>
      ) : error || !data ? (
        <Error message=" عذرا ,لم نتمكن من عرض الاجتماع " error={error} />
      ) : (
        <Meeting meeting={data.data.meeting} />
      )}
    </div>
  )
}
