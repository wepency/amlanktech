import React, { useState } from "react"
import { FileWithPath } from "@mantine/dropzone"

const useFilesState = () => {
  const [files, setFiles] = useState<FileWithPath[]>([])

  const handleDrop = (files: FileWithPath[]) => {
    setFiles((pre) => {
      return [...pre, files[0]]
    })
  }
  const handleRemoveFile = (index: number) => {
    setFiles((pre) => pre.filter((file, i) => i != index))
  }
  const removeAllFiles = () => {
    setFiles([])
  }
  return {
    files,
    setFiles,
    handleDrop,
    handleRemoveFile,
    removeAllFiles,
  }
}

export default useFilesState
