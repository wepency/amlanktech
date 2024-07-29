"use client"

import React from "react"
import { FileWithPath } from "@mantine/dropzone"

type Props = {
  file: FileWithPath
  handleRemoveFile: (index: number) => void
  index: number
}

const FilePreview = ({ file, handleRemoveFile, index }: Props) => {
  return (
    <div className="relative rounded-lg border border-gray-200 shadow-lg">
      <button
        type="button"
        onClick={() => handleRemoveFile(index)}
        className="absolute -end-1 -top-1 rounded-full border border-gray-300 bg-gray-100 p-1">
        <span className="sr-only">Close</span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          className="h-3 w-3"
          viewBox="0 0 20 20"
          fill="currentColor">
          <path
            fillRule="evenodd"
            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
            clipRule="evenodd"
          />
        </svg>
      </button>

      <div className="flex items-center gap-4 p-4">
        <div>
          <p className="font-medium text-gray-900">{file.name}</p>

          <p className="line-clamp-1 text-sm text-gray-500">
            {Math.round(Number(file.size) / 1024)}KB
          </p>
        </div>
      </div>
    </div>
  )
}

export default FilePreview
