import AmlackApi from ".."

export const getPosts = async ({
  pageParam,
  association_id,
}: {
  pageParam: string | number
  association_id: string
}) => {
  let url = `/posts?page=${pageParam}`

  const response = await AmlackApi.get(url, {
    params: {
      association_id,
    },
  })
  return response.data
}
