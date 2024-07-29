"use client"

import React, { useRef, useState } from "react"
import { useParams } from "next/navigation"
import { addReply } from "@/api/helpers/add-replay"
import { objectToFormData } from "@/utils/obj-to-formdata"
import { Button, Textarea } from "@mantine/core"
import { Dropzone } from "@mantine/dropzone"
import { IconFileUpload } from "@tabler/icons-react"
import { useQueryClient } from "@tanstack/react-query"
import { useSession } from "next-auth/react"

import useFilesState from "@/hooks/use-files-state"

import FilePreview from "../../ui/file-preview"

const AddReply = () => {
  const { files, handleDrop, handleRemoveFile, removeAllFiles } = useFilesState()

  const openRef = useRef<() => void>(null)
  const queryClient = useQueryClient()
  const { ticket_id } = useParams() as {
    ticket_id: string
  }
  const [value, setValue] = useState("")
  const [error, setError] = useState("")
  const [isLoading, setIsLoading] = useState(false)

  const handleAddReplay: React.FormEventHandler<HTMLFormElement> = async (e) => {
    e.preventDefault()
    try {
      setIsLoading(true)
      setError("")
      const formData = objectToFormData({ reply: value })
      files.forEach((file, index) => {
        formData.append("attachments[]", file, file.name)
      })
      const response = await addReply({
        ticket_id,
        body: formData,
      })
      await queryClient.refetchQueries({
        queryKey: ["ticket", ticket_id],
        exact: true,
      })
      setValue("")
      removeAllFiles()
    } catch (error: any) {
      setError(error?.message || "لم يتم اضافة الرد")
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <>
      <div className="my-4 flex flex-wrap gap-4  pt-4">
        {files.map((file, index) => {
          return (
            <FilePreview
              key={`file_${file.name}_${index}`}
              file={file}
              handleRemoveFile={handleRemoveFile}
              index={index}
            />
          )
        })}
      </div>
      <form onSubmit={handleAddReplay} className=" flex items-center gap-3 py-4">
        <Textarea
          error={error}
          required
          value={value}
          onChange={(e) => {
            setValue(e.target.value)
          }}
          rows={5}
          placeholder="ردك..."
          className="grow"
        />
        <div className="flex flex-col gap-4 ">
          <Button loading={isLoading} type="submit">
            اضافة رد
          </Button>
          <Dropzone openRef={openRef} onDrop={handleDrop} activateOnClick={false}>
            <Button
              variant="light"
              onClick={() => openRef.current?.()}
              style={{ pointerEvents: "all" }}>
              <IconFileUpload />
            </Button>
          </Dropzone>
        </div>
      </form>
    </>
  )
}

export default AddReply
