import { UnitsResponse } from "@/types/units-response"

import AmlackApi from ".."

export const getUnits = async ({
  pageParam,
  association_id,
}: {
  pageParam: string
  association_id: string
}) => {
  let url = `/units?page=${pageParam}`
  const response = await AmlackApi.get<UnitsResponse>(url)

  return response.data
}
