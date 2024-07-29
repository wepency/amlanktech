import React from "react"
import { getUnits } from "@/api/helpers/get-units"
import { dehydrate, HydrationBoundary, QueryClient } from "@tanstack/react-query"

import Units from "@/components/dashboard/units/units"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  // prefetching meetings for SSR
  const queryClient = new QueryClient()
  await queryClient.prefetchInfiniteQuery({
    queryKey: ["units", association_id],
    queryFn: async ({ pageParam }) =>
      await getUnits({
        pageParam: pageParam + "",
        association_id,
      }),
    initialPageParam: 1,
  })
  return (
    <section>
      <HydrationBoundary state={dehydrate(queryClient)}>
        <Units />
      </HydrationBoundary>
    </section>
  )
}

export default page
