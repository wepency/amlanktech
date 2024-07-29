import { CategoriesResponse } from "@/types/ticket-categories-response"

import AmlackApi from ".."

export const getTicketCategories = async ({
  association_id,
}: {
  association_id: string
}) => {
  let url = `/lists/ticket-categories`
  const response = await AmlackApi.get<CategoriesResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
