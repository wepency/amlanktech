import AmlackApi from ".."

type AddCommentResponse = {
  data: ["تم اضافة التعليق بنجاح."]
  message: null
  success: true
}
export const addComment = async ({
  postID,
  comment,
}: {
  postID: number
  comment: string
}) => {
  const response = await AmlackApi.post<AddCommentResponse>(
    `/posts/${postID}/add-comment`,
    {
      comment,
    },
  )

  return response.data
}
