import { UnitResponse } from "@/types/units-response"

import AmlackApi from ".."

export const getUnit = async ({ unit_id }: { unit_id: string }) => {
  let url = `/units/${unit_id}`
  const response = await AmlackApi.get<UnitResponse>(url)

  return response.data
}
