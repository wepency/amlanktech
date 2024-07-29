import { AddNewTicketSchema } from "@/validation/add-new-ticket"
import { z } from "zod"

import AmlackApi from ".."

type AddCommentResponse = {
  data: ["تم اضافة التعليق بنجاح."]
  message: null
  success: true
}
export const addComment = async ({
  body,
}: {
  token: string
  body: z.infer<typeof AddNewTicketSchema>
}) => {
  const response = await AmlackApi.post<AddCommentResponse>(
    `/requests/add-comment`,
    body,
  )

  return response.data
}
