"use client"

import {
  Button,
  Group,
  Paper,
  SimpleGrid,
  Text,
  Textarea,
  TextInput,
} from "@mantine/core"

import { ContactIconsList } from "./contact-icon"
import classes from "./GetInTouch.module.css"

export function GetInTouch() {
  return (
    <Paper shadow="md" radius="lg">
      <div className={classes.wrapper + "  bg-Primary"}>
        <div className={classes.contacts + "  bg-Primary"}>
          <Text fz="lg" fw={700} className={classes.title} c="#fff">
            معلومات التواصل
          </Text>

          <ContactIconsList />
        </div>

        <form className={classes.form} onSubmit={(event) => event.preventDefault()}>
          <Text fz="lg" fw={700} className={classes.title}>
            تواصل معنا
          </Text>

          <div className={classes.fields}>
            <SimpleGrid cols={{ base: 1, sm: 2 }}>
              <TextInput label="اسمك" placeholder="الاسم بالكامل" />
              <TextInput
                label="الايميل"
                placeholder="example@example.dev"
                required
              />
            </SimpleGrid>

            <TextInput mt="md" label="الموضوع" placeholder="الموضوع" required />

            <Textarea
              required
              mt="md"
              label="رسالتك"
              placeholder="الرجاء كتابة الرسالة بعناية"
              minRows={3}
            />

            <Group justify="flex-end" mt="md">
              <Button type="submit" className={classes.control}>
                ارسال
              </Button>
            </Group>
          </div>
        </form>
      </div>
    </Paper>
  )
}
