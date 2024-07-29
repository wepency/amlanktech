import AmlackApi from ".."

export const deletePermit = async ({ id }: { id: string | number }) => {
  const response = await AmlackApi.delete(`/permits/${id}`)

  return response.data
}
