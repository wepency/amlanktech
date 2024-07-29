import React from "react"
import { getSubscriptions } from "@/api/helpers/get-subscriptions"
import { dehydrate, HydrationBoundary, QueryClient } from "@tanstack/react-query"

import Subscriptions from "@/components/dashboard/subscriptions/subscriptions"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  // prefetching meetings for SSR
  const queryClient = new QueryClient()
  await queryClient.prefetchQuery({
    queryKey: ["subscriptions", association_id],
    queryFn: async () =>
      await getSubscriptions({
        association_id,
      }),
  })
  return (
    <section>
      <HydrationBoundary state={dehydrate(queryClient)}>
        <Subscriptions />
      </HydrationBoundary>
    </section>
  )
}

export default page
