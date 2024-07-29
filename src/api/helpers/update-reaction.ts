import axios from "axios"

import AmlackApi from ".."

type AddCommentResponse = {
  data: ["تم اضافة التعليق بنجاح."]
  message: null
  success: true
}
export const updateReaction = async ({
  postID,
  type,
}: {
  postID: number
  type: "like" | "dislike" | null
}) => {
  const response = await AmlackApi.post<AddCommentResponse>(
    `/posts/${postID}/update-reactions`,
    {
      type,
    },
  )

  return response.data
}
