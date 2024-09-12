"use client"

import AmlackApi from "@/api"
import { ContactSchema } from "@/validation/contact"
import { zodResolver } from "@hookform/resolvers/zod"
import {
  Button,
  Group,
  Paper,
  SimpleGrid,
  Text,
  Textarea,
  TextInput,
} from "@mantine/core"
import { notifications } from "@mantine/notifications"
import { Controller, useForm } from "react-hook-form"
import { object, z } from "zod"

import { ContactIconsList } from "./contact-icon"
import classes from "./GetInTouch.module.css"

export function GetInTouch() {
  const { control, handleSubmit, formState, setError, reset } = useForm<
    z.infer<typeof ContactSchema>
  >({
    resolver: zodResolver(ContactSchema),
    defaultValues: {
      name: "",
      email: "",
      subject: "",
      message: "",
    },
  })
  const onSubmit = handleSubmit(async (data) => {
    try {
      const response = await AmlackApi.post("/contact-us", data)
      // notifications.show({
      //   title:"",
      // })
      notifications.show({
        title: "شكرا لتواصلك معنا",
        message: "سيتم التواصل معك في اقرب وقت ممكن",
      })

      reset()
    } catch (error: any) {
      setError("root", {
        message:
          error?.response?.data?.message || error.response?.message || error.message,
      })
      console.log("🚀 ~ onSubmit ~ error:", error)
    }
  })
  return (
    <Paper shadow="md" radius="lg">
      <div className={classes.wrapper + "  bg-Primary"}>
        <div className={classes.contacts + "  bg-Primary"}>
          <Text fz="lg" fw={700} className={classes.title} c="#fff">
            معلومات التواصل
          </Text>

          <ContactIconsList />
        </div>

        <form className={classes.form} noValidate onSubmit={onSubmit}>
          <Text fz="lg" fw={700} className={classes.title}>
            تواصل معنا
          </Text>

          <div className={classes.fields}>
            <SimpleGrid cols={{ base: 1, sm: 2 }}>
              <Controller
                control={control}
                name="name"
                render={({ field }) => {
                  return (
                    <TextInput
                      error={formState.errors.name?.message}
                      label="اسمك"
                      placeholder="الاسم بالكامل"
                      {...field}
                    />
                  )
                }}
              />
              <Controller
                control={control}
                name="email"
                render={({ field }) => {
                  return (
                    <TextInput
                      label="الايميل"
                      placeholder="example@example.dev"
                      required
                      error={formState.errors.email?.message}
                      {...field}
                    />
                  )
                }}
              />
            </SimpleGrid>

            <Controller
              control={control}
              name="subject"
              render={({ field }) => {
                return (
                  <TextInput
                    mt="md"
                    label="الموضوع"
                    placeholder="الموضوع"
                    error={formState.errors.subject?.message}
                    {...field}
                  />
                )
              }}
            />
            <Controller
              control={control}
              name="message"
              render={({ field }) => {
                return (
                  <Textarea
                    required
                    mt="md"
                    label="رسالتك"
                    placeholder="الرجاء كتابة الرسالة بعناية"
                    minRows={3}
                    error={formState.errors.message?.message}
                    {...field}
                  />
                )
              }}
            />

            {formState.errors.root?.message && (
              <Text c="red" size="sm" mt="md">
                {formState.errors.root.message}
              </Text>
            )}

            <Group justify="flex-end" mt="md">
              <Button
                loading={formState.isSubmitting}
                type="submit"
                className={classes.control}>
                ارسال
              </Button>
            </Group>
          </div>
        </form>
      </div>
    </Paper>
  )
}
