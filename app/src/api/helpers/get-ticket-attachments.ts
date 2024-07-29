import AmlackApi from ".."

type AttachmentsResponse = {
  data: [
    {
      id: 9
      path: string
    },
  ]
}
export const getTicketAttachments = async ({ ticket_id }: { ticket_id: string }) => {
  let url = `/support-tickets/${ticket_id}/attachments`
  const response = await AmlackApi.get<AttachmentsResponse>(url, {})

  return response.data
}
