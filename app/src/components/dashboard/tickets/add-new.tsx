"use client"

import React, { useState } from "react"
import { useParams } from "next/navigation"
import AmlackApi from "@/api"
import { getAssociations } from "@/api/helpers/get-associations"
import { getTicketCategories } from "@/api/helpers/get-ticket-categories"
import { getUnitsList } from "@/api/helpers/get-units-list"
import { objectToFormData } from "@/utils/obj-to-formdata"
import { AddNewTicketSchema } from "@/validation/add-new-ticket"
import { DevTool } from "@hookform/devtools"
import { zodResolver } from "@hookform/resolvers/zod"
import { Button, Modal, Select, Textarea, TextInput } from "@mantine/core"
import { useDisclosure } from "@mantine/hooks"
import { notifications } from "@mantine/notifications"
import { IconCirclePlus } from "@tabler/icons-react"
import { useQueryClient } from "@tanstack/react-query"
import axios from "axios"
import { useSession } from "next-auth/react"
import { Controller, SubmitHandler, useForm } from "react-hook-form"
import { z } from "zod"

import useFilesState from "@/hooks/use-files-state"
import DynamicSelect from "@/components/ui/dynamic-select"
import { DropzoneButton } from "@/components/dropzone/dropzone"

import FilePreview from "../../ui/file-preview"

type Props = {}

const AddNewTicket = (props: Props) => {
  const [opened, { open, close }] = useDisclosure(false)

  const session = useSession()
  const { association_id } = useParams() as { association_id: string }

  // form state using react hook form
  const {
    control,
    setError,
    formState: { errors, isSubmitting, isSubmitted },
    handleSubmit,
    reset,
  } = useForm<z.infer<typeof AddNewTicketSchema>>({
    resolver: zodResolver(AddNewTicketSchema),
    defaultValues: {
      association_id,
      subject: "",
      body: "",
      importance: "normal",
    },
  })

  const queryClient = useQueryClient()

  const { files, handleDrop, handleRemoveFile, removeAllFiles } = useFilesState()

  // handling adding a new request
  const onSubmit: SubmitHandler<z.infer<typeof AddNewTicketSchema>> = async (
    data,
  ) => {
    const formData = objectToFormData(data)
    files.forEach((file, index) => {
      formData.append("attachments[]", file, file.name)
    })
    try {
      const response = await AmlackApi.post("/support-tickets", formData, {
        headers: {
          Authorization: `Bearer ${session.data?.user.access_token}`,
        },
      })
      notifications.show({
        title: "تمت العملية بنجاح",
        message:
          "تم تقديم الطلب الخاص بك بنجاح, سيتم الرد عليك من قبل ادارة الجمعية",
      })
      await queryClient.invalidateQueries({
        queryKey: ["tickets", association_id],
      })
      reset()
      close()
      removeAllFiles()
    } catch (error: any) {
      if (axios.isAxiosError(error) && error.message == "Network Error") {
        setError("root", {
          message: "الرجاء التاكد من اتصالك بالانترنت",
        })
        return
      }
      if (axios.isAxiosError(error) && error.response?.status == 422) {
        for (let key in error.response.data.errors[0]) {
          setError(
            //@ts-expect-error
            key,
            { message: error.response?.data?.errors[0]?.[key][0] },
            { shouldFocus: true },
          )
        }

        return
      }
      if (axios.isAxiosError(error) && error.message == "Network Error") {
        setError("root", {
          message: "الرجاء التاكد من اتصالك بالانترنت",
        })
        return
      }
      if (error.message) {
        setError("root", {
          message: error.message,
        })
        return
      }
      setError("root", {
        message: "لم يتم اضافة الملف",
      })
    }
  }

  return (
    <>
      <Button
        onClick={open}
        color="green"
        className=" max-sm:pr-0"
        rightSection={
          <span className="block shrink-0 ">
            <IconCirclePlus color="green" stroke={1} />
          </span>
        }
        variant="outline">
        <span className="max-sm:hidden">اضافة طلب</span>
      </Button>
      <Modal centered opened={opened} onClose={close} title="اضافة طلب جديد">
        <form noValidate onSubmit={handleSubmit(onSubmit)}>
          <div className=" space-y-3">
            <Controller
              name="association_id"
              control={control}
              render={({ field }) => (
                <DynamicSelect
                  readOnly
                  queryFn={getAssociations}
                  queryKey="associations"
                  label="أختر الجمعية"
                  placeholder="اختر جمعية"
                  formatData={(data) => {
                    const associations = data?.data.associations.map(
                      (element, index) => {
                        return { value: element.id + "", label: element.name }
                      },
                    )
                    return associations
                  }}
                  error={errors.association_id?.message}
                  {...field}
                />
              )}
            />
            <Controller
              name="category_id"
              control={control}
              render={({ field }) => (
                <DynamicSelect
                  queryFn={async () => {
                    return await getTicketCategories({
                      association_id,
                    })
                  }}
                  queryKey="ticket-categories"
                  label="نوع الطلب"
                  placeholder="اختر نوع الطلب"
                  formatData={(data) => {
                    const associations = data?.data.categories.map(
                      (element, index) => {
                        return { value: element.id + "", label: element.name }
                      },
                    )
                    return associations
                  }}
                  error={errors.category_id?.message}
                  {...field}
                />
              )}
            />
            <Controller
              name="unit_id"
              control={control}
              render={({ field }) => (
                <DynamicSelect
                  queryFn={async () => {
                    return await getUnitsList({
                      association_id,
                    })
                  }}
                  queryKey="units-list"
                  label="الوحدة"
                  placeholder="اختر  الوحدة"
                  formatData={(data) => {
                    const associations = data?.data?.units?.map((element, index) => {
                      return { value: element.id + "", label: element.unit_no }
                    })
                    return associations
                  }}
                  error={errors.unit_id?.message}
                  {...field}
                />
              )}
            />
            <Controller
              name="subject"
              control={control}
              render={({ field }) => (
                <TextInput
                  {...field}
                  error={errors.subject?.message}
                  label="عنوان الطلب"
                  placeholder="عنوان"
                  required
                />
              )}
            />
            <Controller
              name="importance"
              control={control}
              render={({ field }) => (
                <Select
                  {...field}
                  error={errors.importance?.message}
                  label="الأولوية"
                  placeholder="حدد الالولية"
                  data={[
                    { value: "normal", label: "عادي" },
                    { value: "average", label: "متوسط" },
                    { value: "urgent", label: "عالي" },
                  ]}
                  required
                />
              )}
            />
            <Controller
              name="body"
              control={control}
              render={({ field }) => (
                <Textarea
                  rows={9}
                  description="الرجاء  كتابة تفاصيل الطلب بعناية"
                  {...field}
                  error={errors.body?.message}
                  label="الطلب"
                  placeholder="تفاصيل الطلب"
                  required
                />
              )}
            />
            <DropzoneButton handleDrop={handleDrop} />
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
            {errors.root ? (
              <p className="py-3 text-center text-sm text-red-500">
                {errors.root.message}
              </p>
            ) : null}
            <Button loading={isSubmitting} type="submit" fullWidth mt="xl">
              تقديم الطلب
            </Button>
          </div>
        </form>
      </Modal>
      <DevTool control={control} placement="top-left" />
    </>
  )
}

export default AddNewTicket
