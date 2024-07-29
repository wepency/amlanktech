import React from "react"
import { getSystemDocs } from "@/api/helpers/get-system-documents"

import SystemDocuments from "@/components/dashboard/association-system/system-documents"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  const documents = await getSystemDocs({
    association_id,
  })

  return (
    <section>
      <SystemDocuments
        title="سجلات النظام"
        documents={documents.data.system_documents}
      />
    </section>
  )
}

export default page
