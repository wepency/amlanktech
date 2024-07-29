import React from "react"
import { getTickets } from "@/api/helpers/get-tickets"
import { dehydrate, HydrationBoundary, QueryClient } from "@tanstack/react-query"

import Tickets from "@/components/dashboard/tickets/tickets"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  // prefetching meetings for SSR
  const queryClient = new QueryClient()
  await queryClient.prefetchQuery({
    queryKey: ["tickets", association_id],
    queryFn: async () =>
      await getTickets({
        association_id,
      }),
  })
  return (
    <section>
      <HydrationBoundary state={dehydrate(queryClient)}>
        <Tickets />
      </HydrationBoundary>
    </section>
  )
}

export default page
