import { TicketsResponse } from "@/types/tickets-response"

import AmlackApi from ".."

export const getOtherTickets = async ({
  association_id,
  ticket_id,
}: {
  association_id: string
  ticket_id: string
}) => {
  let url = `/support-tickets/${ticket_id}/others`
  const response = await AmlackApi.get<TicketsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
