import { Box, rem, Stack, Text } from "@mantine/core"
import { IconAt, IconMapPin, IconPhone, IconSun } from "@tabler/icons-react"

import classes from "./ContactIcon.module.css"

interface ContactIconProps
  extends Omit<React.ComponentPropsWithoutRef<"div">, "title"> {
  icon: typeof IconSun
  title: React.ReactNode
  description: React.ReactNode
}

function ContactIcon({
  icon: Icon,
  title,
  description,
  ...others
}: ContactIconProps) {
  return (
    <div className={classes.wrapper} {...others}>
      <Box mr="md">
        <Icon style={{ width: rem(24), height: rem(24) }} />
      </Box>

      <div>
        <Text size="xs" className={classes.title}>
          {title}
        </Text>
        <Text className={classes.description}>{description}</Text>
      </div>
    </div>
  )
}

const MOCKDATA = [
  { title: "الايميل", description: "Qarnim@amlaktech.com", icon: IconAt },
  { title: "الهاتف", description: "0544696753", icon: IconPhone },
  {
    title: "العنوان",
    description: "المملكة العربية السعودية الرياض - جدة",
    icon: IconMapPin,
  },
  { title: "ساعات العمل", description: "٩ صباحًا - ٦ مساءاً", icon: IconSun },
]

export function ContactIconsList() {
  const items = MOCKDATA.map((item, index) => <ContactIcon key={index} {...item} />)
  return <Stack>{items}</Stack>
}
