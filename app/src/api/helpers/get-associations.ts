import { AssociationsResponse } from "@/types/associations-response"

import AmlackApi from ".."

export const getAssociations = async () => {
  let url = `/lists/associations`
  const response = await AmlackApi.get<AssociationsResponse>(url, {})

  return response.data
}
