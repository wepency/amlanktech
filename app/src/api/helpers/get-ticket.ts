import { TicketResponse } from "@/types/ticket-response"

import AmlackApi from ".."

export const getTicket = async ({ ticket_id }: { ticket_id: string }) => {
  let url = `/support-tickets/${ticket_id}`
  const response = await AmlackApi.get<TicketResponse>(url, {})

  return response.data
}
