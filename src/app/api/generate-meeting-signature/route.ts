import { NextResponse } from "next/server"

const KJUR = require("jsrsasign")

async function generateSignature(meetingNumber: string, role: string) {
  const iat = Math.round(new Date().getTime() / 1000) - 30
  const exp = iat + 60 * 60 * 2

  const appKey = process.env.NEXT_PUBLIC_ZOOM_MEETING_CLIENT_ID
  const secretKey = process.env.ZOOM_MEETING_SDK_SECRET!

  const oPayload = {
    sdkKey: appKey,
    appKey: appKey,
    mn: meetingNumber,
    role: role,
    iat: iat,
    exp: exp,
    tokenExp: exp,
  }
  const oHeader = { alg: "HS256", typ: "JWT" }
  const sHeader = JSON.stringify(oHeader)
  const sPayload = JSON.stringify(oPayload)
  const sdkJWT = KJUR.jws.JWS.sign("HS256", sHeader, sPayload, secretKey)
  console.log("🚀 ~ generateSignature ~ sdkJWT:", sdkJWT)
  return sdkJWT
}

export const POST = async (req: Request) => {
  try {
    const { meetingNumber, role } = await req.json()
    if (!meetingNumber || typeof role === undefined)
      return new Response("failed", { status: 422 })
    console.log(meetingNumber, role)
    const sdkJWT = await generateSignature(meetingNumber, role)
    return NextResponse.json({ signature: sdkJWT })
  } catch (error) {
    return NextResponse.json({ error: "server error" }, { status: 500 })
  }
}
