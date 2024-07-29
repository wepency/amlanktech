import React from "react"
import { getAssociationSys } from "@/api/helpers/get-association-systems"

import SystemDocuments from "@/components/dashboard/association-system/system-documents"

type Props = {
  params: {
    association_id: string
  }
}

const page = async ({ params: { association_id } }: Props) => {
  const documents = await getAssociationSys({
    association_id,
  })

  return (
    <section>
      <SystemDocuments
        title="نظام الجمعية"
        documents={documents.data.system_documents}
      />
    </section>
  )
}

export default page
