import React from "react"
import { getPermits } from "@/api/helpers/get-permits"
import { dehydrate, HydrationBoundary, QueryClient } from "@tanstack/react-query"

import Permits from "@/components/dashboard/permits/permits"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  // prefetching meetings for SSR
  const queryClient = new QueryClient()
  await queryClient.prefetchQuery({
    queryKey: ["permits", association_id],
    queryFn: async () => {
      return await getPermits({
        association_id,
      })
    },
  })
  return (
    <section>
      <HydrationBoundary state={dehydrate(queryClient)}>
        <Permits />
      </HydrationBoundary>
    </section>
  )
}

export default page
