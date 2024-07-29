"use client"

import { useEffect, useState } from "react"
import Image from "next/image"
import Link from "next/link"
import { useRouter } from "next/navigation"
import { logo } from "@/assets"
import { LoginSchema } from "@/validation/login"
import { DevTool } from "@hookform/devtools"
import { zodResolver } from "@hookform/resolvers/zod"
import {
  Anchor,
  Button,
  Checkbox,
  Container,
  Group,
  Paper,
  PasswordInput,
  rem,
  Text,
  TextInput,
  Title,
} from "@mantine/core"
import { notifications } from "@mantine/notifications"
import { IconAt } from "@tabler/icons-react"
import { signIn } from "next-auth/react"
import { Controller, SubmitHandler, useForm } from "react-hook-form"
import { z } from "zod"

export default function Login() {
  // form state using react hook form
  const {
    control,
    setError,
    formState: { errors, isSubmitting, isSubmitted },
    handleSubmit,
  } = useForm<z.infer<typeof LoginSchema>>({
    resolver: zodResolver(LoginSchema),
    defaultValues: {
      username: "",
      password: "",
    },
  })
  const router = useRouter()

  // handling login
  const onSubmit: SubmitHandler<z.infer<typeof LoginSchema>> = async (data) => {
    try {
      const response = await signIn("credentials", {
        username: data.username,
        password: data.password,
        redirect: false,
      })
      if (response?.error) throw new Error(response.error)
      if (response?.ok) {
        router.push("/dashboard")
        return
      }
      if (!response?.ok) {
        throw new Error("البيانات التلي قمت بادخالها خاطئة")
      }
    } catch (error: any) {
      console.log(
        "🚀 ~ constonSubmit:SubmitHandler<z.infer<typeofLoginSchema>>= ~ error:",
        error,
      )

      setError("root", {
        message: error.message || "حصل خطأ ما الرجاء المحاولة مجددا",
      })
    }
  }

  useEffect(() => {
    const searchParams = new URL(window.location.href).searchParams

    const timer = setTimeout(() => {
      if (
        new Date(searchParams.get("date")!).toDateString() ===
        new Date().toDateString()
      ) {
        notifications.show({
          title: "تم تقديم الطلب بنجاح",
          message:
            "تم تقديم طلبك بنجاح, سيتم مراجعة طلبك من قبل ادارة الجمعية في اسرع وقت ممكن",
        })
      }
    }, 1000)

    return () => {
      clearTimeout(timer)
    }
  }, [])
  return (
    <main className="relative z-[1] py-10 ">
      <Container size={450} className=" flex h-screen items-center">
        <form onSubmit={handleSubmit(onSubmit)} noValidate className="block w-full">
          <Title ta="center" className="mb-3 font-bold">
            اهلا بك في املاك
          </Title>
          <Text c="dimmed" size="sm" ta="center" mt={5}>
            ليس لديك حساب?{" "}
            <Anchor size="sm" href={"/register"} component={Link}>
              إنشأ حساب
            </Anchor>
          </Text>

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
                name="username"
                control={control}
                render={({ field }) => (
                  <TextInput
                    {...field}
                    error={errors.username?.message}
                    leftSection={
                      <IconAt style={{ width: rem(16), height: rem(16) }} />
                    }
                    label="إيميل"
                    placeholder="you@example.com"
                    required
                    description="يمكنك تسجيل الدخول باستخدام الايميل الخاص بك او رقم الجوال"
                  />
                )}
              />
              <Controller
                name="password"
                control={control}
                render={({ field }) => (
                  <PasswordInput
                    {...field}
                    error={errors.password?.message}
                    label="كلمة المرور"
                    placeholder="****"
                    required
                    mt="md"
                  />
                )}
              />

              {/* <Group justify="space-between" mt="lg">
                <Anchor href={"/forgot-password"} component={Link} size="sm">
                  نسيت كلمة المرور؟
                </Anchor>
              </Group> */}
            </div>
            <Button loading={isSubmitting} type="submit" fullWidth mt="xl">
              تسجيل الدخول
            </Button>
            {errors.root ? (
              <p className="py-3 text-center text-sm text-red-500">
                {errors.root.message}
              </p>
            ) : null}
          </Paper>
          <DevTool control={control} placement="top-left" />
        </form>
      </Container>
    </main>
  )
}
