"use client"

import { useState } from "react"
import Image from "next/image"
import Link from "next/link"
import { useParams } from "next/navigation"
import AmlackApi from "@/api"
import { logo } from "@/assets"
import { RegisterAssociationSchema } from "@/validation/register-association"
import { DevTool } from "@hookform/devtools"
import { zodResolver } from "@hookform/resolvers/zod"
import {
  Button,
  Container,
  Paper,
  PasswordInput,
  Select,
  TextInput,
  Title,
} from "@mantine/core"
import { Controller, SubmitHandler, useForm } from "react-hook-form"
import { z } from "zod"

export interface RegisterResponse {
  data: Data
  message: null
  success: boolean
}

export interface Data {
  message: string
  payment_link: string
  association: Association
}

export interface Association {
  name: string
  map_link: string
  registration_number: string
  subscription_period: string
  subscription_start_date: Date
  address: string
  updated_at: Date
  created_at: Date
  id: number
  admin_id: number
}

export default function Page() {
  const { plan_id } = useParams()
  // form state using react hook form
  const {
    control,
    formState: { errors, isSubmitting, isSubmitted },
    handleSubmit,
    setError,
  } = useForm<z.infer<typeof RegisterAssociationSchema>>({
    resolver: zodResolver(RegisterAssociationSchema),
    defaultValues: {
      manager_name: "",
      password: "",
      password_confirmation: "",
      national_id: "",
      phone_number: "",
      email: "",
      association_name: "",
      address: "",
      map_link: "",
      registration_number: "",
      subscription_period: undefined,
    },
  })

  const [paymentLink, setPaymentLink] = useState("")

  // handling login
  const onSubmit: SubmitHandler<z.infer<typeof RegisterAssociationSchema>> = async (
    data,
  ) => {
    try {
      const response = await AmlackApi.post<RegisterResponse>(
        "/associations/register",
        { ...data, plan_id },
      )
      setPaymentLink(response.data.data.payment_link)
      window.open(paymentLink, "_blank")
    } catch (error: any) {
      setError("root", {
        message:
          error.response?.data?.message || error.response?.message || error.message,
      })
    }
  }

  return (
    <main className="relative z-[1] py-10 ">
      <Container size={450} className=" flex min-h-screen items-center">
        <form onSubmit={handleSubmit(onSubmit)} noValidate className="block w-full">
          <Title ta="center" className="mb-3 font-bold">
            اهلا بك في املاك
          </Title>

          <Paper withBorder shadow="md" p={30} mt={110} radius="md" className="">
            <div>
              <Link
                href={"/"}
                className="mx-auto -mt-28 block aspect-square w-fit rounded-full border-t bg-white p-4">
                <Image src={logo} alt="logo" className=" mx-auto mb-5 w-32 " />
              </Link>
            </div>
            <div className=" space-y-3">
              <Controller
                name="manager_name"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    placeholder="اسم مدير الجمعية"
                    label="اسم مدير الجمعية"
                    error={errors.manager_name?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="phone_number"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="رقم الهاتف"
                    placeholder="*** **** ***"
                    error={errors.phone_number?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="email"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="البريد الإلكتروني"
                    placeholder="you@example.com"
                    error={errors.email?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="password"
                control={control}
                render={({ field }) => (
                  <PasswordInput
                    required
                    label="كلمة المرور"
                    placeholder="****"
                    error={errors.password?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="password_confirmation"
                control={control}
                render={({ field }) => (
                  <PasswordInput
                    required
                    label="تأكيد كلمة المرور"
                    placeholder="****"
                    error={errors.password_confirmation?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="national_id"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="رقم الهوية"
                    placeholder="****"
                    error={errors.national_id?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="association_name"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="اسم الجمعية"
                    placeholder="اسم الجمعية"
                    error={errors.association_name?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="address"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="العنوان"
                    placeholder="العنوان"
                    error={errors.address?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="map_link"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="رابط الخريطة"
                    placeholder="رابط الخريطة"
                    error={errors.map_link?.message}
                    {...field}
                  />
                )}
              />

              <Controller
                name="registration_number"
                control={control}
                render={({ field }) => (
                  <TextInput
                    required
                    label="رقم التسجيل"
                    placeholder="****"
                    error={errors.registration_number?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="subscription_period"
                control={control}
                render={({ field }) => (
                  <Select
                    label="أختر الجمعية"
                    placeholder="اختر جمعية"
                    data={[
                      {
                        value: "1",
                        label: "شهريا",
                      },
                      {
                        value: "3",
                        label: "ربع سنوي",
                      },
                      {
                        value: "6",
                        label: "نصف سنوي",
                      },
                      {
                        value: "12",
                        label: "سنويا",
                      },
                    ]}
                    error={errors.subscription_period?.message}
                    {...field}
                  />
                )}
              />
            </div>
            <Button loading={isSubmitting} type="submit" fullWidth mt="xl">
              تسجيل الجمعية
            </Button>
            {errors.root ? (
              <p className="py-3 text-center text-sm text-red-500">
                {errors.root.message}
              </p>
            ) : null}

            {paymentLink ? (
              <p>
                في حال عدم تحويلك لبوابة الدفع{" "}
                <a href={paymentLink} target="_blank" rel="noopener">
                  اضغط هنا
                </a>
              </p>
            ) : null}
          </Paper>
          <DevTool control={control} placement="top-left" />
        </form>
      </Container>
    </main>
  )
}
