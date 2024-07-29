import { SystemDocumentsResponse } from "@/types/system-documents-response"

import AmlackApi from ".."

export const getSystemDocs = async ({
  association_id,
}: {
  association_id: string
}) => {
  let url = `/system-documents`
  const response = await AmlackApi.get<SystemDocumentsResponse>(url, {
    params: {
      association_id,
    },
  })

  return response.data
}
