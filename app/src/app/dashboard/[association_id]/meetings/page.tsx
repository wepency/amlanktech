import React from "react"
import { getMeetings } from "@/api/helpers/get-meetings"
import { dehydrate, HydrationBoundary, QueryClient } from "@tanstack/react-query"

import Meetings from "@/components/dashboard/meetings/meetings"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  // prefetching meetings for SSR
  const queryClient = new QueryClient()
  await queryClient.prefetchInfiniteQuery({
    queryKey: ["meetings", association_id],
    queryFn: async ({ pageParam }) =>
      await getMeetings({
        pageParam: pageParam + "",
        association_id,
      }),

    initialPageParam: 1,
  })
  return (
    <div className=" min-h-[calc(100vh-110px)] rounded-lg border bg-white  px-4 py-6 pb-10 shadow">
      <h1 className="mb-10 text-xl font-bold">جميع الاجتماعات</h1>
      <HydrationBoundary state={dehydrate(queryClient)}>
        <Meetings />
      </HydrationBoundary>
    </div>
  )
}

export default page
