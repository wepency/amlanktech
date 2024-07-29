"use client"

import React, { useEffect } from "react"
import { useParams } from "next/navigation"
import AmlackApi from "@/api"
import { AddPermitSchema } from "@/validation/add-permit"
import { DevTool } from "@hookform/devtools"
import { zodResolver } from "@hookform/resolvers/zod"
import {
  ActionIcon,
  Button,
  Modal,
  Select,
  Textarea,
  TextInput,
} from "@mantine/core"
import { DatePickerInput } from "@mantine/dates"
import { useDisclosure } from "@mantine/hooks"
import { notifications } from "@mantine/notifications"
import { IconCirclePlus, IconTrash } from "@tabler/icons-react"
import { useQueryClient } from "@tanstack/react-query"
import axios from "axios"
import { useSession } from "next-auth/react"
import { Controller, SubmitHandler, useFieldArray, useForm } from "react-hook-form"
import { z } from "zod"

import "@mantine/dates/styles.css"

import { getAssociations } from "@/api/helpers/get-associations"

import DynamicSelect from "@/components/ui/dynamic-select"

type Props = {}

const AddPermit = (props: Props) => {
  const [opened, { open, close }] = useDisclosure(false)
  const session = useSession()
  const { association_id } = useParams() as { association_id: string }

  // form state using react hook form
  const {
    control,
    setError,
    formState: { errors, isSubmitting },
    handleSubmit,
    reset,
  } = useForm<z.infer<typeof AddPermitSchema>>({
    resolver: zodResolver(AddPermitSchema),
    defaultValues: {
      association_id,
      visitors: [{ national_id: "", visitor_name: "" }],
    },
  })
  const { fields, append, remove } = useFieldArray({
    //@ts-ignore
    name: "visitors", // unique name for your Field Array
    control,
  })

  const addVisitor = () => {
    append({ visitor_name: "", national_id: "" })
  }

  const queryClient = useQueryClient()

  // handling adding a new request
  const onSubmit: SubmitHandler<z.infer<typeof AddPermitSchema>> = async (data) => {
    try {
      await AmlackApi.post("/permits", data, {
        headers: {
          Authorization: `Bearer ${session.data?.user.access_token}`,
        },
      })
      await queryClient.invalidateQueries({
        queryKey: ["permits", association_id],
      })
      notifications.show({
        title: "تمت العملية بنجاح",
        message:
          "تم تقديم  التصريح الخص بك بنجاح, سيتم كراجعته من قبل ادارة الجمعية",
      })
      reset()
      close()
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
        <span className="max-sm:hidden">اضافة تصريح</span>
      </Button>
      <Modal
        centered
        opened={opened}
        size={"lg"}
        onClose={close}
        title="اضافة تصريح جديد">
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
              name="type"
              control={control}
              render={({ field }) => (
                <Select
                  {...field}
                  label="نوع التصريح"
                  placeholder="نوع التصريح"
                  data={[
                    {
                      label: "صيانة",
                      value: "maintenance",
                    },
                    {
                      label: "عامل",
                      value: "worker",
                    },
                    {
                      label: "توصيل",
                      value: "deliver",
                    },
                    {
                      label: "زائر",
                      value: "visitor",
                    },
                  ]}
                  error={errors.type?.message}
                  required
                />
              )}
            />
            <Controller
              name="login_attempts"
              control={control}
              render={({ field }) => (
                <TextInput
                  {...field}
                  error={errors.login_attempts?.message}
                  label="مرات الدخول"
                  placeholder="مرات الدخول"
                  required
                />
              )}
            />
            <Controller
              name="permit_days"
              control={control}
              render={({ field }) => (
                <TextInput
                  {...field}
                  error={errors.permit_days?.message}
                  label="عدد ايام التصريج"
                  placeholder="عدد ايام التصريح"
                  required
                />
              )}
            />
            <Controller
              name="start_date"
              control={control}
              render={({ field }) => (
                <DatePickerInput
                  {...field}
                  error={errors.start_date?.message}
                  label="تاريخ السريان"
                  placeholder="اختر تاريخ السريان"
                  required
                />
              )}
            />

            {fields.map((field, index) => (
              <div key={field.id} className=" flex gap-3">
                <Controller
                  name={`visitors.${index}.visitor_name`}
                  control={control}
                  render={({ field }) => (
                    <TextInput
                      className="grow"
                      {...field}
                      error={errors.visitors?.[index]?.visitor_name?.message}
                      label="الزائرين"
                      placeholder="الزائرين"
                      required
                    />
                  )}
                />
                <Controller
                  name={`visitors.${index}.national_id`}
                  control={control}
                  render={({ field }) => (
                    <TextInput
                      className="grow"
                      {...field}
                      error={errors.visitors?.[index]?.national_id?.message}
                      label="رقم الهوية"
                      placeholder="رقم الهوية"
                      required
                    />
                  )}
                />
                {index !== 0 ? (
                  <ActionIcon
                    onClick={() => {
                      remove(index)
                    }}
                    className=" mb-1 self-end"
                    variant="transparent">
                    <IconTrash className="text-red-500" />
                  </ActionIcon>
                ) : null}
              </div>
            ))}

            <Button
              color="green"
              onClick={addVisitor}
              type="button"
              variant="outline">
              اضافة زائر
            </Button>

            {errors.root ? (
              <p className="py-3 text-center text-sm text-red-500">
                {errors.root.message}
              </p>
            ) : null}
            <Button loading={isSubmitting} type="submit" fullWidth mt="xl">
              تقديم التصريح
            </Button>
          </div>
        </form>
      </Modal>
      <DevTool control={control} placement="top-left" />
    </>
  )
}

export default AddPermit
