import React from "react"

import { SystemDocument } from "@/types/system-documents-response"
import SystemDocTable from "@/components/table/system-document-table"

type Props = {
  documents: SystemDocument[]
  title: string
}

const SystemDocuments = ({ documents, title }: Props) => {
  return (
    <div>
      <div className="mt-6 min-h-[calc(100vh-130px)] rounded-lg border bg-white px-4 py-6   shadow">
        <div className="mb-10 flex justify-between">
          <h1 className=" text-xl font-bold">{title}</h1>
        </div>

        {documents.length === 0 ? (
          <p className="p-4 text-center">لا يوجد اي سجلات </p>
        ) : (
          <SystemDocTable data={documents} />
        )}
      </div>
    </div>
  )
}

export default SystemDocuments
