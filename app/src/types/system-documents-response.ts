export type SystemDocumentsResponse = {
  data: Data
  message: string | null
  success: boolean
}

export type Data = {
  system_documents: SystemDocument[]
}

export type SystemDocument = {
  id: number
  title: string
  document_link?: string
  file_path?: string
  created_at: string
}
