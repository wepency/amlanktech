import { TicketsResponse } from "@/types/tickets-response"

import AmlackApi from ".."

export const getTickets = async ({ association_id }: { association_id: string }) => {
  let url = `/support-tickets`
  const response = await AmlackApi.get<TicketsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
