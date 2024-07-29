import { UnitsListResponse } from "@/types/units-list-response"

import AmlackApi from ".."

export const getUnitsList = async ({
  association_id,
}: {
  association_id: string
}) => {
  let url = `/lists/units`
  const response = await AmlackApi.get<UnitsListResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
