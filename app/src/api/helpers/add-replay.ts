import AmlackApi from ".."

type AddReply = {
  data: ["تم اضافة الرد بنجاح."]
  message: null
  success: true
}
export const addReply = async ({
  ticket_id,
  body,
}: {
  ticket_id: string
  body: FormData
}) => {
  const response = await AmlackApi.post<AddReply>(
    `/support-tickets/${ticket_id}/reply`,
    body,
  )

  return response.data
}
