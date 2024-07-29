import React from "react"
import { getPolls } from "@/api/helpers/get-polls"
import { dehydrate, HydrationBoundary, QueryClient } from "@tanstack/react-query"

import Polls from "@/components/dashboard/polls/polls"

type Props = {
  params: {
    association_id: string
  }
}

const Page = async ({ params: { association_id } }: Props) => {
  const queryClient = new QueryClient()
  await queryClient.prefetchQuery({
    queryKey: ["polls", association_id],
    queryFn: async () =>
      await getPolls({
        association_id,
      }),
  })
  return (
    <div className=" min-h-[calc(100vh-100px)] rounded-lg border bg-white  px-4 py-6 pb-10 shadow">
      <h1 className="mb-10 text-xl font-bold">جميع التصويتات</h1>
      <HydrationBoundary state={dehydrate(queryClient)}>
        <Polls />
      </HydrationBoundary>
    </div>
  )
}

export default Page
