import { Group, rem, Text, useMantineTheme } from "@mantine/core"
import { Dropzone, FileWithPath, MIME_TYPES } from "@mantine/dropzone"
import { IconCloudUpload, IconDownload, IconX } from "@tabler/icons-react"

import "@mantine/dropzone/styles.css"

import classes from "./dropzone.module.css"

type Props = {
  handleDrop: (files: FileWithPath[]) => void
}

export function DropzoneButton({ handleDrop }: Props) {
  const theme = useMantineTheme()

  return (
    <div className={classes.wrapper}>
      <Dropzone
        onDrop={handleDrop}
        className={classes.dropzone}
        radius="md"
        accept={[
          MIME_TYPES.pdf,
          MIME_TYPES.jpeg,
          MIME_TYPES.png,
          MIME_TYPES.doc,
          MIME_TYPES.docx,
          MIME_TYPES.ppt,
          MIME_TYPES.pptx,
        ]}
        maxSize={10 * 1024 ** 2}>
        <div style={{ pointerEvents: "none" }}>
          <Group justify="center">
            <Dropzone.Accept>
              <IconDownload
                style={{ width: rem(50), height: rem(50) }}
                color={theme.colors.blue[6]}
                stroke={1.5}
              />
            </Dropzone.Accept>
            <Dropzone.Reject>
              <IconX
                style={{ width: rem(50), height: rem(50) }}
                color={theme.colors.red[6]}
                stroke={1.5}
              />
            </Dropzone.Reject>
            <Dropzone.Idle>
              <IconCloudUpload
                style={{ width: rem(50), height: rem(50) }}
                stroke={1.5}
              />
            </Dropzone.Idle>
          </Group>

          <Text ta="center" fw={700} fz="lg" mt="xl">
            <Dropzone.Accept>اسحب وافلت هنا</Dropzone.Accept>
            <Dropzone.Reject>حجم الملف لا يزيد عن 10mb</Dropzone.Reject>
            <Dropzone.Idle>رفع ملف</Dropzone.Idle>
          </Text>
          <Text ta="center" fz="sm" mt="xs" c="dimmed">
            اسحب وافلت هنا, نقبل ملفات <i>pdf</i> التي هي اقل من 30md
          </Text>
        </div>
      </Dropzone>
    </div>
  )
}
