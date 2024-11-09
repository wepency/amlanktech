"use client"

import { useState } from "react"
import Image from "next/image"
import Link from "next/link"
import { useRouter } from "next/navigation"
import AmlackApi from "@/api"
import { getAssociations } from "@/api/helpers/get-associations"
import { logo } from "@/assets"
import { registerSchema } from "@/validation/register"
import { DevTool } from "@hookform/devtools"
import { zodResolver } from "@hookform/resolvers/zod"
import {
  Box,
  Button,
  Checkbox,
  Container,
  Paper,
  PasswordInput,
  rem,
  Select,
  Text,
  TextInput,
  Title,
} from "@mantine/core"
import { IconAt, IconLoader2, IconPercentage } from "@tabler/icons-react"
import { useQuery } from "@tanstack/react-query"
import axios from "axios"
import { Controller, SubmitHandler, useForm } from "react-hook-form"
import { z } from "zod"

export default function Register() {
  // form state using react hook form
  const {
    control,
    setError,
    formState: { errors, isSubmitting, isSubmitted },
    handleSubmit,
    watch,
  } = useForm<z.infer<typeof registerSchema>>({
    resolver: zodResolver(registerSchema),
    defaultValues: {
      name: "",
      phone_number: "",
      email: "",
      password: "",
      password_confirmation: "",
      association_id: "",
      ownership_type: "individual",
      unit_address: "",
      water_meter_serial: "",
      electricity_meter_serial: "",
      unit_name: "",
      partners_amount: "",
      ownership_ratio: "",
      fee_type_value: ""
    },
  })
  const { data, isLoading, error } = useQuery({
    queryKey: ["lists", "associations"],
    queryFn: getAssociations,
  })

  const associations = data?.data.associations.map((element, index) => {
    return { value: element.id + "", label: element.name, id: element.id }
  })

  const selectedAssociation = data?.data.associations.find(
    (e) => e.id + "" === watch("association_id"),
  )
  const [checked, setChecked] = useState(false)
  const router = useRouter()

  const onSubmit: SubmitHandler<z.infer<typeof registerSchema>> = async (data) => {
    try {
      if (!checked) throw new Error("الرجاء الموافقة على الشروط و الاحكام")
      data.fee_type_id = selectedAssociation!.feeType?.id + "" || ""
      const response = await AmlackApi.post("/register", data)
      if (response.status === 200)
        router.push(
          `/login?success=true&name=${data.name}&date=${new Date().toDateString()}`,
        )
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
    }
  }

  return (
    <main className=" relative z-[1] py-20 ">
      <Container size={450} className=" flex  items-center">
        <form onSubmit={handleSubmit(onSubmit)} className="block w-full" noValidate>
          <Title ta="center" className="mb-3 font-bold">
            اهلا بك في املاك
          </Title>
          <Text c="dimmed" ta="center" mt={5}>
            تقديم طلب عضوية
          </Text>

          <Paper withBorder shadow="md" p={30} mt={110} radius="md">
            <div>
              <Link
                href={"/"}
                className="mx-auto -mt-28 block aspect-square w-fit rounded-full border-t bg-white p-4">
                <Image src={logo} alt="logo" className=" mx-auto  w-32 " />
              </Link>
            </div>
            <div className=" space-y-3">
              <Controller
                name="name"
                control={control}
                render={({ field }) => (
                  <TextInput
                    {...field}
                    label="الاسم"
                    placeholder="اسمك بالكامل"
                    error={errors.name?.message}
                  />
                )}
              />
              <Controller
                name="phone_number"
                control={control}
                render={({ field }) => (
                  <TextInput
                    label="رقم الجوال"
                    placeholder="+966 *** *** ***"
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
                    leftSection={
                      <IconAt style={{ width: rem(16), height: rem(16) }} />
                    }
                    label="إيميل"
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
                    label="تاكيد كلمة المرور"
                    placeholder="****"
                    required
                    error={errors.password_confirmation?.message}
                    {...field}
                  />
                )}
              />
            </div>
            <div className="mt-6 space-y-3">
              <p className=" text-xl font-bold">بيانات الوحدة</p>
              <Controller
                name="association_id"
                control={control}
                render={({ field }) => (
                  <Select
                    rightSection={
                      isLoading ? (
                        <IconLoader2 stroke={1.5} className="animate-spin" />
                      ) : null
                    }
                    disabled={isLoading}
                    label="أختر الجمعية"
                    placeholder="اختر جمعية"
                    data={associations}
                    error={errors.association_id?.message || error?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="unit_name"
                control={control}
                render={({ field }) => (
                  <TextInput
                    label="اسم الوحدة"
                    placeholder="الاسم"
                    error={errors.unit_name?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="ownership_type"
                control={control}
                render={({ field }) => (
                  <Select
                    label="العقار يتبع لفرد ام مجموعة؟"
                    data={[
                      {
                        label: "فرد",
                        value: "individual",
                      },
                      {
                        label: "مجموعة",
                        value: "group",
                      },
                    ]}
                    error={errors.ownership_type?.message}
                    {...field}
                  />
                )}
              />
              {watch("ownership_type") === "group" ? (
                <>
                  <Controller
                    name="partners_amount"
                    control={control}
                    render={({ field }) => (
                      <TextInput
                        label="عدد الشركاء"
                        placeholder="العدد"
                        error={errors.partners_amount?.message}
                        {...field}
                      />
                    )}
                  />
                  <Controller
                    name="ownership_ratio"
                    control={control}
                    render={({ field }) => (
                      <TextInput
                        leftSection={<IconPercentage stroke={1.4} size={20} />}
                        label="نسبة الشراكة"
                        placeholder="النسبة"
                        error={errors.ownership_ratio?.message}
                        {...field}
                      />
                    )}
                  />
                </>
              ) : null}
              <Controller
                name="unit_address"
                control={control}
                render={({ field }) => (
                  <TextInput
                    label="عنوان الوحدة"
                    placeholder="عنوان الوحدة"
                    error={errors.unit_address?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="water_meter_serial"
                control={control}
                render={({ field }) => (
                  <TextInput
                    label="رقم عداد المياه"
                    placeholder=" رقم عداد المياه"
                    error={errors.water_meter_serial?.message}
                    {...field}
                  />
                )}
              />
              <Controller
                name="electricity_meter_serial"
                control={control}
                render={({ field }) => (
                  <TextInput
                    label="رقم عداد الكهرباء"
                    placeholder="رقم عداد الكهرباء"
                    error={errors.electricity_meter_serial?.message}
                    {...field}
                  />
                )}
              />
              {selectedAssociation && selectedAssociation.feeType ? (
                <Controller
                  name="fee_type_value"
                  control={control}
                  render={({ field }) => (
                    <TextInput
                      label={selectedAssociation.feeType?.label}
                      placeholder={selectedAssociation.feeType?.label}
                      error={errors.fee_type_value?.message}
                      {...field}
                    />
                  )}
                />
              ) : null}
              <Checkbox
                checked={checked}
                onChange={(e) => setChecked(e.target.checked)}
                label="انا أوافق على الشروط والأحكام."
                required
              />
            </div>

            <Button loading={isSubmitting} type="submit" fullWidth mt="xl">
              تقديم طلب الانضمام
            </Button>
            {errors.root ? (
              <p className="py-3 text-center text-sm text-red-500">
                {errors.root.message}
              </p>
            ) : null}
            <div className="mt-3 text-sm text-gray-500">
              <Box ml={5}>
                لديك حساب بالفعل؟{" "}
                <Link href={"/login"} className="text-Primary">
                  {" "}
                  سجل دخول
                </Link>
              </Box>
            </div>
          </Paper>
          <DevTool control={control} placement="top-left" />
        </form>
      </Container>
    </main>
  )
}
